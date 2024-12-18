package com.gabcytn.i_capture.Aspect;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.annotation.AfterThrowing;
import org.aspectj.lang.annotation.Aspect;
import org.aspectj.lang.annotation.Before;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

import java.time.LocalDateTime;
import java.util.Arrays;

@Aspect
@Component
public class LoggingAspect {
    private final Logger LOGGER = LoggerFactory.getLogger(LoggingAspect.class);

    @Before("execution(* com.gabcytn.i_capture..*(..))")
    public void logCalledMethodsName(JoinPoint joinPoint) {
        LOGGER.info("Method called: {}. Class: {}. Arguments: {}. Timestamp: {}",
                joinPoint.getSignature().getName(),
                joinPoint.getTarget().getClass().getName(),
                Arrays.toString(joinPoint.getArgs()),
                LocalDateTime.now());
    }

    @AfterThrowing(pointcut = "execution(* com.gabcytn.i_capture..*(..))", throwing = "exception")
    public void logErrorsMethodName(JoinPoint joinPoint, Throwable exception) {
        LOGGER.error("Exception in method: {}. Class: {}. Arguments: {}. Exception: {}. Timestamp: {}",
                joinPoint.getSignature().getName(),
                joinPoint.getTarget().getClass().getName(),
                Arrays.toString(joinPoint.getArgs()),
                exception.getMessage(),
                LocalDateTime.now());
    }
}

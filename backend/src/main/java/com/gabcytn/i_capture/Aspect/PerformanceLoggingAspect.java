package com.gabcytn.i_capture.Aspect;

import org.aspectj.lang.ProceedingJoinPoint;
import org.aspectj.lang.annotation.Around;
import org.aspectj.lang.annotation.Aspect;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

@Aspect
@Component
public class PerformanceLoggingAspect {
    private final Logger LOGGER = LoggerFactory.getLogger(PerformanceLoggingAspect.class);

    @Around("execution(* com.gabcytn.i_capture.Service.UserService.getUserCredentialsByUsername(..)) || " +
            "execution(* com.gabcytn.i_capture.Service.FollowersService.follow(..)) || " +
            "execution(* com.gabcytn.i_capture.Service.FollowersService.unfollow(..)) || " +
            "execution(* com.gabcytn.i_capture.Service.PostsService.*(..))")
    public Object logPerformance (ProceedingJoinPoint joinPoint) throws Throwable {
        long initTime = System.currentTimeMillis();
        Object object = joinPoint.proceed();

        long finalTime = System.currentTimeMillis();
        long timePassed = finalTime - initTime;

        LOGGER.info("{} took {} ms", joinPoint.getSignature().getName(), timePassed);

        return object;
    }
}
